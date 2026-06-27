# Резервное копирование и восстановление БД

Схема резервного копирования — ежедневный инкрементный бэкап базы MySQL.

## 1. Как устроено

- **Полный дамп** снимается скриптом `scripts/backup_db.sh` раз в сутки.
- При каждом запуске выполняется `--flush-logs`, что начинает новый двоичный лог (binlog).
- **Инкременты** — это binlog-файлы между полными дампами: они содержат все изменения.
- Опция `--master-data=2` записывает в дамп позицию binlog, от которой восстанавливать инкременты.
- Копии старше `KEEP_DAYS` (по умолчанию 14 дней) удаляются автоматически.

## 2. Включить binlog в MySQL

В `/etc/mysql/mysql.conf.d/mysqld.cnf`:

```ini
[mysqld]
server-id = 1
log_bin = /var/log/mysql/mysql-bin.log
binlog_expire_logs_seconds = 1209600
binlog_format = ROW
```

Перезапустить: `sudo systemctl restart mysql`.

## 3. Расписание (cron)

Ежедневно в 03:30:

```cron
30 3 * * * DB_PASS='пароль' /var/www/gamestore/scripts/backup_db.sh >> /var/log/gamestore-backup.log 2>&1
```

## 4. Восстановление

### 4.1. Из полного дампа

```bash
gunzip < /var/backups/gamestore/gamestore_2026-06-27_033000.sql.gz | mysql -u root -p gamestore
```

### 4.2. Донакатить инкременты (point-in-time)

После разворачивания полного дампа применяем binlog с нужной позиции:

```bash
# позиция видна в шапке дампа: CHANGE MASTER TO MASTER_LOG_FILE=..., MASTER_LOG_POS=...
mysqlbinlog --start-position=4 /var/log/mysql/mysql-bin.000123 | mysql -u root -p gamestore

# или восстановление на конкретный момент времени
mysqlbinlog --stop-datetime="2026-06-27 14:00:00" /var/log/mysql/mysql-bin.000123 | mysql -u root -p gamestore
```

## 5. Проверка восстановления

Рекомендуется раз в месяц разворачивать бэкап на тестовой БД и проверять целостность данных.
