package com.ibm.ptt.just.processor;

import org.apache.log4j.Logger;

public class Log{
    private static org.apache.log4j.Logger log = Logger
	    .getLogger(Log.class);

    
    public static void main(String[] args) {

			log.trace("Trace");
			log.debug("Debug");
			log.info("Info");
			log.warn("Warn");
			log.error("Error");
			log.fatal("Fatal");

    }





}
