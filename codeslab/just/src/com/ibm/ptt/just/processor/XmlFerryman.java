package com.ibm.ptt.just.processor;

import java.io.Reader;

import org.apache.log4j.Logger;

import com.ibm.ptt.just.meta.JustDescriptor;
import com.ibm.ptt.just.meta.User;
import com.thoughtworks.xstream.XStream;
import com.thoughtworks.xstream.io.xml.DomDriver;

/**
 * This class provides methods for serilizing and deserilizing between XML and Java object 
 * 
 * @author Woody
 * @version 1.0
 */
public class XmlFerryman {

	private static Logger log = Logger.getLogger(XmlFerryman.class);

	private static XStream xstream = new XStream(new DomDriver());

	static {
		xstream.alias("users", User[].class);
		xstream.alias("user", User.class);
		xstream.alias("JustDescriptor", JustDescriptor.class);
	}

	/**
	 * Serialize a Java object to XML string 
	 * 
	 * @param <T> Bean type
	 * @param obj Java Object
	 * @return serialized xml string
	 */
	public static<T> String toXML(T obj) {
		return xstream.toXML(obj);
	}

	/**
	 * Deserialize an XML string to Java object
	 * 
	 * @param <T> Bean type
	 * @param reader input reader for XML file
	 * @return Java object
	 */
	@SuppressWarnings("unchecked")
	public static<T> T fromXML(Reader reader) {
		try {
			return (T)xstream.fromXML(reader);
		} catch (Exception e) {
			log.fatal("Failed to parse the configuration file.");
			throw new RuntimeException(e);
		}
	}

	/**
	 * Deserialize an XML string to Java object
	 * 
	 * @param <T> Bean type
	 * @param xmlString XML string for deserializing
	 * @return Java object
	 */
	@SuppressWarnings("unchecked")
	public static<T> T fromXML(String xmlString) {
		try {
			return (T)xstream.fromXML(xmlString);
		} catch (Exception e) {
			log.fatal("Failed to parse the configuration file.");
			throw new RuntimeException(e);
		}
	}
}