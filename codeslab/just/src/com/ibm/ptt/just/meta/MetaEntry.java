package com.ibm.ptt.just.meta;

import java.util.HashMap;
import java.util.Map;

/**
 * This is a utility class
 * 
 * @author Woody
 * @version 1.0
 */
public class MetaEntry extends MetaInfo {
	private String key;
	private String val;
	private String desc;
	private Object tag;
	private Map<String, Object> kv;

	public String getKey() {
		return key;
	}

	public void setKey(String key) {
		this.key = key;
	}

	public String getVal() {
		return val;
	}

	public void setVal(String val) {
		this.val = val;
	}

	public String getDesc() {
		return desc;
	}

	public void setDesc(String desc) {
		this.desc = desc;
	}

	public Object getTag() {
		return tag;
	}

	public void setTag(Object tag) {
		this.tag = tag;
	}

	@SuppressWarnings("unchecked")
	public <T> T getKv(String k) {
		return (T)kv.get(k);
	}

	public void setKv(String k, Object v) {
		if (kv == null) {
			kv = new HashMap<String, Object>();
		}
		this.kv.put(k, v);
	}
}
