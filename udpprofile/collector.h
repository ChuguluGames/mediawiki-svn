/* Collector structures and some headers and some data */
/* $Id$ */

#include <stdio.h>
#include <db.h>

DB *db;

/* Stats variables, not that generic, are they? */
struct pfstats {
	unsigned long pf_count;
	/* CPU time of event */
	double pf_cpu;
	double pf_cpu_sq;
	double pf_real;
	double pf_real_sq;
};

void dumpData(FILE *);

