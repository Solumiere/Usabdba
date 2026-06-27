#!/usr/bin/env bash
#
# Ежедневный инкрементный бэкап БД (MySQL).
# Использует mysqldump --single-transaction + flush binlog,
# чтобы снятие копии не блокировало таблицы InnoDB.
#
# Инкрементность обеспечивают двоичные логи (binlog): полный дамп с --master-data=2
# фиксирует позицию, а последующие binlog-файлы — это приращения.
set -euo pipefail

# === Настройки ===
DB_NAME="${DB_NAME:-gamestore}"
DB_USER="${DB_USER:-backup}"
DB_PASS="${DB_PASS:-}"
DB_HOST="${DB_HOST:-127.0.0.1}"
BACKUP_DIR="${BACKUP_DIR:-/var/backups/gamestore}"
KEEP_DAYS="${KEEP_DAYS:-14}"

DATE="$(date +%F_%H%M%S)"
DEST="${BACKUP_DIR}/${DB_NAME}_${DATE}.sql.gz"

mkdir -p "${BACKUP_DIR}"

# Полный логический дамп + сброс binlog (начало нового инкремента)
mysqldump --single-transaction --quick --routines --triggers --events --flush-logs --master-data=2 -h "${DB_HOST}" -u "${DB_USER}" -p"${DB_PASS}" "${DB_NAME}" | gzip -9 > "${DEST}"

echo "[ОК] Бэкап создан: ${DEST}"

# Ротация: удаляем копии старше KEEP_DAYS дней
find "${BACKUP_DIR}" -name "${DB_NAME}_*.sql.gz" -type f -mtime +"${KEEP_DAYS}" -delete

echo "[ОК] Старые копии (>${KEEP_DAYS} дн.) удалены"
