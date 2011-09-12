package com.ibm.ptt.just.processor;

import java.io.BufferedReader;
import java.io.FileWriter;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.URL;
import java.net.URLConnection;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import javax.script.ScriptEngine;
import javax.script.ScriptEngineManager;
import javax.script.ScriptException;

import org.apache.log4j.Logger;

import com.ibm.ptt.just.meta.JustDescriptor;
import com.ibm.ptt.just.meta.MetaEntry;
import com.ibm.ptt.just.meta.User;

/**
 * This class is used to get users' information from PTT API per rules defined in the configuration file
 * 
 * @author Woody
 * @version 1.0
 */
public class PttApiHandler {

	private static Logger log = Logger.getLogger(PttApiHandler.class);

	/**
	 * Request users from PTT API<br>
	 * Users' information can be retrieved in every entry's tag of group mapping.<br />
	 * You can edit skip rule in the configuration file.
	 * 
	 * @param justDesc the configuration information
	 */
	public static void requestPttApi(JustDescriptor justDesc) {
		try {
			MetaEntry[] groupMapping = justDesc.getGroupMapping();
			for (MetaEntry entry : groupMapping) {
				// check role pattern
				String val = entry.getVal();
				if (val == null || !val.matches("^\\d+(,\\d+)*$")) {
					log.fatal("Role mapping is invalid. Format '/^\\d+(,\\d+)*$/' is expected.");
					throw new RuntimeException();
				}
				List<User> userList = new ArrayList<User>();
				entry.setTag(userList);
				for (String roleId : val.split(",")) {
					// Create a URLConnection object for a URL
					URL url = new URL(justDesc.getParameter("PTT_API_URI_USERS") + roleId);
					URLConnection conn = url.openConnection();
					conn.setRequestProperty("User-Agent", justDesc.getParameter("User-Agent"));
					conn.setRequestProperty("X-PTT-API-Key", justDesc.getParameter("X-PTT-API-Key"));
					conn.connect();
					BufferedReader in = new BufferedReader(new InputStreamReader(
							(InputStream) conn.getContent()));
					StringBuilder strBuilder = new StringBuilder();
					String inputLine;
					while ((inputLine = in.readLine()) != null) {
						strBuilder.append(inputLine);
					}
					in.close();
					// convert XML to User class
					User[] users = XmlFerryman.fromXML(strBuilder.toString());
					// apply the skip rule
					ScriptEngineManager mgr = new ScriptEngineManager();
					ScriptEngine jsEngine = mgr.getEngineByName("JavaScript");
					for (User user : users) {
						// apply the skip rule
						try {
							jsEngine.put("user", user);
							jsEngine.eval(justDesc.getSkipRule());
							if (Boolean.valueOf(jsEngine.eval("skip_user()").toString())) {
								log.info(String.format("User(%s) is skipped.", user.getEmail()));
								continue;
							}
						} catch (ScriptException ex) {
							log.fatal("Failed to execute the script for rules skipping.");
							throw new RuntimeException();
						}
						userList.add(user);
						if (Boolean.valueOf(justDesc.getParameter("TEST_ONLY", "false")) && userList.size() >= 3) {
							break;
						}
					}
					if (Boolean.valueOf(justDesc.getParameter("ENABLE_BULK_PROCESS", "false"))) {
						// export the users' emails for bluk adding
						String filename = String.format("%s%s-%s-%s.txt",
							justDesc.getParameter("TEMP_FILE_DIR"),
							new SimpleDateFormat("yyyyMMddHHmmss.S").format(new Date()), 
							entry.getKey(), 
							roleId);
						FileWriter memberListWriter = new FileWriter(filename);
						for (User user : userList) {
							memberListWriter.write(user.getEmail() + "\n");
						}
						memberListWriter.close();
						// set the temp file name
						entry.setKv(entry.getKey() + roleId, filename);
					}
				}
			}
		} catch (Exception e) {
			log.fatal("Failed to get information from PTT API.");
			throw new RuntimeException(e);
		}
	}
}
