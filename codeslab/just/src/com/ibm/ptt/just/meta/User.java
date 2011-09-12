package com.ibm.ptt.just.meta;

/**
 * User bean 
 * 
 * @author Woody
 * @version 1.0
 */
public class User extends MetaInfo {
	private String id;
	private String name;
	private String description;
	private String email;
	private String hours;
	private String phone;

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

	public String getDescription() {
		return description;
	}

	public void setDescription(String description) {
		this.description = description;
	}

	public String getEmail() {
		return email;
	}

	public void setEmail(String email) {
		this.email = email;
	}

	public String getHours() {
		return hours;
	}

	public void setHours(String hours) {
		this.hours = hours;
	}

	public String getPhone() {
		return phone;
	}

	public void setPhone(String phone) {
		this.phone = phone;
	}

	public String getManagerUserId() {
		return managerUserId;
	}

	public void setManagerUserId(String managerUserId) {
		this.managerUserId = managerUserId;
	}

	public String getTimezone() {
		return timezone;
	}

	public void setTimezone(String timezone) {
		this.timezone = timezone;
	}

	public String getCountryId() {
		return countryId;
	}

	public void setCountryId(String countryId) {
		this.countryId = countryId;
	}

	public String getSpdId() {
		return spdId;
	}

	public void setSpdId(String spdId) {
		this.spdId = spdId;
	}

	public String getIsAdmin() {
		return isAdmin;
	}

	public void setIsAdmin(String isAdmin) {
		this.isAdmin = isAdmin;
	}

	public String getIsSuperadmin() {
		return isSuperadmin;
	}

	public void setIsSuperadmin(String isSuperadmin) {
		this.isSuperadmin = isSuperadmin;
	}

	public Role getPrimaryRole() {
		return primaryRole;
	}

	public void setPrimaryRole(Role primaryRole) {
		this.primaryRole = primaryRole;
	}

	public Role[] getRoles() {
		return roles;
	}

	public void setRoles(Role[] roles) {
		this.roles = roles;
	}

	private String managerUserId;
	private String timezone;
	private String countryId;
	private String spdId;
	private String isAdmin;
	private String isSuperadmin;
	private Role primaryRole;
	private Role[] roles;
}
