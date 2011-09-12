package com.ibm.ptt.just.processor;

import java.io.File;
import java.io.FileWriter;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.List;
import java.util.Vector;

import org.apache.log4j.Logger;

import com.ibm.ed.tool.bluegroups.CWA2Bulk;
import com.ibm.ptt.just.meta.JustDescriptor;
import com.ibm.ptt.just.meta.MetaEntry;
import com.ibm.ptt.just.meta.User;
import com.ibm.swat.password.ReturnCode;
import com.ibm.swat.password.cwa2;

/**
 * This class is used to update all groups to Blue Group
 * 
 * @author Woody
 * @version 1.0
 */
public class BlueGroupHandler {

	private static Logger log = Logger.getLogger(BlueGroupHandler.class);

	/**
	 * Create groups on Blue Group with the defination of groups and users.<br />
	 * You can edit skip rule in the configuration file.
	 * 
	 * @param justDesc the configuration information
	 */
	public static void postBlueGroup(JustDescriptor justDesc) {
		ReturnCode rc = null;
		cwa2 blueGroupApi = new cwa2();

		// authenticate username and password for LDAP
		rc = blueGroupApi.authenticate(
					justDesc.getParameter("username"),
					justDesc.getParameter("password"));
		if (rc.getCode() != 0){
			log.fatal(rc.getMessage());
			log.fatal("Failed to authenticate the account.");
			throw new RuntimeException();
		}

		clearSubGroups(blueGroupApi, justDesc);
		createSubGroups(blueGroupApi, justDesc);
		if (Boolean.valueOf(justDesc.getParameter("ENABLE_BULK_PROCESS", "false"))) {
			if ("cwa2".equals(justDesc.getParameter("BULK_PROCESSOR", "ed"))) {
				updateBulkUsersToBlueGroupByCwa2(blueGroupApi, justDesc);
			} else {
				updateBulkUsersToBlueGroupByEd(justDesc);
			}
		} else {
			updateUsersToBlueGroup(blueGroupApi, justDesc);
		}
	}

	/**
	 * Remove all sub groups
	 * 
	 * @param blueGroupApi blue group API
	 * @param justDesc     the configuration information
	 */
	private static void clearSubGroups(cwa2 blueGroupApi, JustDescriptor justDesc) {
		// clear all sub groups
		ReturnCode rc = null;
		Vector<String> groups = new Vector<String>() ;
		rc = blueGroupApi.listGroups(justDesc.getParameter("ROOT_GROUP_ON_BLUE_GROUP"), groups) ;
		if (rc.getCode() != 0){
			log.warn("Warning: root group is not in the blue group.");
		}
		boolean clearAll = Boolean.valueOf(justDesc.getParameter("CLEAR_ALL_GROUPS_OF_ROOT_GROUP"));
		if (!clearAll) {
			for (MetaEntry entry : justDesc.getGroupMapping()) {
				// detach sub group from the root group
				String group = entry.getKey();
				rc = blueGroupApi.removeSubGroup(
						justDesc.getParameter("username"),
						justDesc.getParameter("password"),
						justDesc.getParameter("ROOT_GROUP_ON_BLUE_GROUP"),
						group);
				if (rc.getCode() != 0){
					log.warn(rc.getMessage());
					log.warn(String.format("Failed to remove the sub group(%s).", group));
				}
				// delete sub group
				rc = blueGroupApi.deleteGroup(
						justDesc.getParameter("username"),
						justDesc.getParameter("password"),
						group);
				if (rc.getCode() != 0){
					log.warn(rc.getMessage());
					log.warn(String.format("Failed to delete the sub group(%s).", group));
				}
			}
			return;
		}
		for (String group : groups) {
			// detach sub group from the root group
			rc = blueGroupApi.removeSubGroup(
					justDesc.getParameter("username"),
					justDesc.getParameter("password"),
					justDesc.getParameter("ROOT_GROUP_ON_BLUE_GROUP"),
					group);
			if (rc.getCode() != 0){
				log.warn(rc.getMessage());
				log.warn(String.format("Failed to remove the sub group(%s).", group));
			}
			// delete sub group
			rc = blueGroupApi.deleteGroup(
					justDesc.getParameter("username"),
					justDesc.getParameter("password"),
					group);
			if (rc.getCode() != 0){
				log.warn(rc.getMessage());
				log.warn(String.format("Failed to delete the sub group(%s).", group));
			}
		}
	}

	/**
	 * Create all sub groups
	 * 
	 * @param blueGroupApi blue group API
	 * @param justDesc     the configuration information
	 */
	private static void createSubGroups(cwa2 blueGroupApi, JustDescriptor justDesc) {
		// create groups for metrics
		ReturnCode rc = null;
		Calendar expirationDate = Calendar.getInstance();
		try {
			expirationDate.setTime((new SimpleDateFormat("yyyy-MM-dd").parse(justDesc.getParameter("EXPIRATION_DATE"))));
		} catch (ParseException e) {
			log.fatal("Failed to parse the expiration date.");
			throw new RuntimeException();
		}
		for (MetaEntry entry : justDesc.getGroupMapping()) {
			// create sub group
			int failCounter = 0;
			while (true) {
				try {
					// wait for network delay
					Thread.sleep(Integer.valueOf(justDesc.getParameter("INTERVAL_TRIES")));
				} catch (InterruptedException e) {
				}
				rc = blueGroupApi.createGroup(
						justDesc.getParameter("username"),
						justDesc.getParameter("password"),
						entry.getKey(),
						String.format(entry.getDesc()),
						1,
						expirationDate.get(Calendar.YEAR),
						expirationDate.get(Calendar.MONTH),
						expirationDate.get(Calendar.DATE));
				if (rc.getCode() != 0){
					failCounter++;
					if (failCounter > Integer.valueOf(justDesc.getParameter("MAX_TRIES"))) {
						throw new RuntimeException();
					}
					log.warn(rc.getMessage());
					log.warn(String.format("Failed to create sub groups(%d)", Integer.valueOf(failCounter)));
				} else {
					break;
				}
			}
			// attach the sub group to the root group
			rc = blueGroupApi.addSubGroup(
					justDesc.getParameter("username"),
					justDesc.getParameter("password"),
					justDesc.getParameter("ROOT_GROUP_ON_BLUE_GROUP"),
					entry.getKey());
			if (rc.getCode() != 0){
				log.fatal(rc.getMessage());
				log.fatal("Failed to add sub groups.");
				throw new RuntimeException();
			}
		}
	}

	/**
	 * Add all users to sub groups
	 * 
	 * @param blueGroupApi blue group API
	 * @param justDesc     the configuration information
	 */
	@SuppressWarnings("unchecked")
	private static void updateUsersToBlueGroup(cwa2 blueGroupApi, JustDescriptor justDesc) {
		// add users for metrics
		ReturnCode rc = null;
		for (MetaEntry entry : justDesc.getGroupMapping()) {
			// add users' information
			log.info(String.format("Group(%s) is processing ...", entry.getKey()));
			for (User user : (List<User>)entry.getTag()) {
				// attach a member to the sub group
				rc = blueGroupApi.addMember(
						justDesc.getParameter("username"),
						justDesc.getParameter("password"),
						entry.getKey(),
						user.getEmail());
				if (rc.getCode() != 0){
					log.warn(String.format("%s => Failed to add users(%s).", rc.getMessage(), user.getEmail()));
				}
			}
		}
	}

	/**
	 * Add all users to sub groups by bulk processing
	 * 
	 * @param blueGroupApi blue group API
	 * @param justDesc     the configuration information
	 */
	private static void updateBulkUsersToBlueGroupByCwa2(cwa2 blueGroupApi, JustDescriptor justDesc) {
		// add users for metrics
		for (MetaEntry entry : justDesc.getGroupMapping()) {
			// import the users' emails for bluk adding
			log.info(String.format("Group(%s) is processing ...", entry.getKey()));
			String val = entry.getVal();
			for (String roleId : val.split(",")) {
				// add all members to the sub group
				// XXX
				// about the usage please refer to http://tst2bluepages.mkm.can.ibm.com/directory/bluegroups/api.shtml#cwa2bulk
				// java com.ibm.ed.tool.bluegroups.CWA2Bulk -r ADD -f members.txt -p sample_cwa2bulk.properties
//				CWA2Bulk.main(new String[]{"-r", "ADD", "-f", "members.txt", "-p", justDesc.getParameter("CWA2BULK.PROPERTIES")});
				// XXX
				// The following snippet is for unrecommanded method of cwa2.jar but it works well!!!
				try {
					String filename = entry.getKv(entry.getKey() + roleId);
					ReturnCode rc = blueGroupApi.addMemberbyFile(
							justDesc.getParameter("username"),
							justDesc.getParameter("password"),
							entry.getKey(),
							"mail",
							filename);
					if (rc.getCode() != 0) {
						log.warn(rc.getMessage());
					}
				} catch (Exception e) {
					log.fatal("Failed to add users by bulk processing.");
					throw new RuntimeException();
				}
			}
		}
	}

	/**
	 * Add all users to sub groups by bulk processing
	 * 
	 * @param justDesc     the configuration information
	 * @deprecated This method haven't be implemented completely, but it's worthy to test for using because of its batch updating function.
	 */
	private static void updateBulkUsersToBlueGroupByEd(JustDescriptor justDesc) {
		if (Boolean.valueOf(true)) {
			throw new RuntimeException("Please use a supported solution for creating groups on Bluegroup, this method is not supported now.");
		}
		// add users for metrics
		for (MetaEntry entry : justDesc.getGroupMapping()) {
			// import the users' emails for bluk adding
			log.info(String.format("Group(%s) is processing ...", entry.getKey()));
			String val = entry.getVal();
			for (String roleId : val.split(",")) {
				// add all members to the sub group
				// about the usage please refer to http://tst2bluepages.mkm.can.ibm.com/directory/bluegroups/api.shtml#cwa2bulk
				// java com.ibm.ed.tool.bluegroups.CWA2Bulk -r ADD -f members.txt -p sample_cwa2bulk.properties
				try {
					// generate *.properties file for user importing
					String propertiesFilename = justDesc.getParameter("TEMP_FILE_DIR") + roleId + ".properties";
					FileWriter w = new FileWriter(new File(propertiesFilename));
					w.write("bluepages.ldap.url=ldap://bluepages.ibm.com\n");
					w.write("bluegroups.ldap.url=ldap://bluegroups.ibm.com\n");
					w.write("group.admin.id=zwren@cn.ibm.com\n");
					w.write("group.admin.psw=******\n");
					w.write("group.name=" + entry.getKey() + "\n");
					w.write("member.attr.id=mail\n");
					w.close();
					String usersFilename = entry.getKv(entry.getKey() + roleId);
					CWA2Bulk.main(new String[]{"-r", "ADD", "-f", usersFilename, "-p", propertiesFilename});
					new File(propertiesFilename).delete();
				} catch (Exception e) {
					log.fatal("Failed to add users by bulk processing.");
					throw new RuntimeException();
				}
			}
		}
	}
}
