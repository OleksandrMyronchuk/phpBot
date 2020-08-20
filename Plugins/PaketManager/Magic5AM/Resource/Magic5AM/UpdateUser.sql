UPDATE _Users
SET
_Username=:_Username,
_FirstName=:_FirstName,
_LastName=:_LastName
WHERE _UserId=:_UserId;
