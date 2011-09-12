package com.ibm.ptt.just.meta;

import java.util.Properties;

import org.apache.log4j.Logger;

/**
 * This class contains all configration information for JUST 
 * 
 * @author Woody
 * @version 1.0
 */
public class JustDescriptor extends MetaInfo {

	private static Logger log = Logger.getLogger(JustDescriptor.class);

	private Properties props;
	private String skipRule
//	= {"1", "2", "3"}
	;
	private MetaEntry[] groupMapping
//	= {
//		new MetaEntry<String>("Manager", "1"),
//		new MetaEntry<String>("WPL", "5"),
//		new MetaEntry<String>("WB", "6,9"),
//		new MetaEntry<String>("QA", "8")
//	}
	;

//	{
//		if (props == null) {
//			props = new Properties();
//		}
//		props.put("bgLogonUser", "zwren@cn.ibm.com");
//		props.put("bgLogonPw", "********");
//		props.put("bgPrefix", "PTT_TEST_Group");
//		props.put("bgBufferTime", "5000");
//		props.put("pttApiUrl", "http://pttapidev2.pok.ibm.com/pttapi/core-ptt/");
//		props.put("User-Agent", "PTT-Core/0.1");
//		props.put("X-PTT-API-Key", "b952fff4652ae3bf3da4420662fa5be6");
//	}

	/**
	 * Get the value of specified property
	 * 
	 * @param key
	 * @return
	 */
	public String getParameter(String key) {
		String value = this.props.getProperty(key);
		if (value == null) {
			log.warn(String.format("The value of key(%s) is missing.", key));
		}
		return value;
	}

	/**
	 * Get the value of specified property, if the value is not found the default value will be returned
	 * 
	 * @param key
	 * @param defaultValue
	 * @return
	 */
	public String getParameter(String key, String defaultValue) {
		String value = this.props.getProperty(key);
		return value == null ? defaultValue : value;
	}

	/**
	 * Get script snippet for the skipping rule
	 * 
	 * @return
	 */
	public String getSkipRule() {
		return skipRule;
	}

	/**
	 * Get groups to roles mapping information
	 * 
	 * @return
	 */
	public MetaEntry[] getGroupMapping() {
		return groupMapping;
	}
}
