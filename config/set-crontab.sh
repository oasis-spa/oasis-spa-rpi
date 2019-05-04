* * * * * wget -q -O - "http://127.0.0.1/cron_jobs/cron_min.php"

1,11,21,31,41,51 * * * * wget -q -O - "http://127.0.0.1/cron_jobs/cron_10minutes.php"

15 03 * * * wget -q -O - "http://127.0.0.1/cron_jobs/cron_day.php"

06 13 * * * find /var/log/* -mtime +5 -type f -delete