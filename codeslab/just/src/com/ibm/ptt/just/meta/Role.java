package com.ibm.ptt.just.meta;

/**
 * Role bean 
 * 
 * @author Woody
 * @version 1.0
 */
public class Role extends MetaInfo {

	private String id;
	private String name;

	public Role() {
		super();
	}

	public Role(String id, String name) {
		super();
		this.id = id;
		this.name = name;
	}

	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}
}
