package com.ibm.ptt.just.meta;

import com.thoughtworks.xstream.XStream;

/**
 * This class provide an overriden toString() method for its sub class
 * 
 * @author Woody
 * @version 1.0
 */
public abstract class MetaInfo {

	@Override
	public String toString() {
		XStream x = new XStream();
		x.alias("".equals(this.getClass().getSimpleName()) ? this.getClass().getSuperclass().getSimpleName() : this.getClass().getSimpleName(), 
				this.getClass());
		return x.toXML(this);
	}
}
