SELECT _UserId, _Username, _FirstName, _LastName FROM _Users
WHERE _Users._UserId IN
(SELECT _DataToExport._userId FROM _DataToExport WHERE
STR_TO_DATE(_DataToExport._telegramTime, '%Y-%m-%d %H:%i') > STR_TO_DATE(CONCAT(:_startDate, ' 00:00'), '%Y-%m-%d %H:%i') &&
STR_TO_DATE(_DataToExport._telegramTime, '%Y-%m-%d %H:%i') < STR_TO_DATE(CONCAT(:_endDate, ' 00:00'), '%Y-%m-%d %H:%i'));
