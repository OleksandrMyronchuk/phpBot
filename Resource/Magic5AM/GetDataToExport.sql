SELECT _userId, _username, _firstName,
_lastName, _telegramTime, _serverTime,
_day, _context
FROM _DataToExport WHERE
STR_TO_DATE(_telegramTime, '%Y-%m-%d %H:%i') > STR_TO_DATE(CONCAT(:_startDate, ' 00:00'), '%Y-%m-%d %H:%i') &&
STR_TO_DATE(_telegramTime, '%Y-%m-%d %H:%i') < STR_TO_DATE(CONCAT(:_endDate, ' 00:00'), '%Y-%m-%d %H:%i');