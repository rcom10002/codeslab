package com.ibm.ptt.just;

import java.io.File;
import java.io.FileReader;

import org.apache.log4j.Logger;

import com.ibm.ptt.just.meta.JustDescriptor;
import com.ibm.ptt.just.processor.BlueGroupHandler;
import com.ibm.ptt.just.processor.PttApiHandler;
import com.ibm.ptt.just.processor.XmlFerryman;

/**
 * This is the main entry of JUST!
 * 
 * java JustMain your_JustDescriptor.xml_path
 * 
 * @author Woody
 * @version 1.0
 */
public class JustMain {

	private static Logger log = Logger.getLogger(JustMain.class);

	/**
	 * 
	 * @param args
	 */
	public static void main(String[] args) {
		try {
			// check the input parameter
			if (args == null || args.length != 1) {
				log.fatal("You must privide only one argument to specify the configuration file path.");
				System.exit(1);
			}
			// check configuration file
			if (!new File(args[0]).exists()) {
				log.fatal("The specified configuration file path is invalid.");
				System.exit(2);
			}
			// load all configuration information
			JustDescriptor justDesc = XmlFerryman.fromXML(new FileReader(args[0]));

			// print starting message
			log.info("Start synchronizing ...");

			// request users from PTT API
			PttApiHandler.requestPttApi(justDesc);

			// post users to blue group
			BlueGroupHandler.postBlueGroup(justDesc);

			// print successful message
			log.info("Java User Sync Tool: done!");
			System.exit(0);
		} catch (Exception e) {
			log.warn(e);
			log.fatal("Java User Sync Tool: failed!");
			System.exit(-1);
		}
	}
}

