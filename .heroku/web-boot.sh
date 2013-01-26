sed -i 's/Listen 80/Listen '$PORT'/' /app/apache/conf/httpd.conf

for var in `env|cut -f1 -d=`; do
  echo "PassEnv $var" >> /app/apache/conf/httpd.conf;
done

echo "Include /app/www/.heroku/*.conf" >> /app/apache/conf/httpd.conf

touch /app/apache/logs/error_log
touch /app/apache/logs/access_log

tail -F /app/apache/logs/error_log &
tail -F /app/apache/logs/access_log &

export LD_LIBRARY_PATH=/app/php/ext
export PHP_INI_SCAN_DIR=/app/www

echo "Launching Apache HTTP Server"
exec /app/apache/bin/httpd -DNO_DETACH
