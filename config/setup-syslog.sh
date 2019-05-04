#!/bin/bash
cat <<EOF >/etc/syslog-ng/conf.d/apache.conf
source s_apache {
    file("/var/log/apache2/access.log" follow-freq(1) flags(no-parse));
    file("/var/log/apache2/error.log" follow-freq(1) flags(no-parse));
};
log { source(s_apache); destination(d_syslog); };
EOF