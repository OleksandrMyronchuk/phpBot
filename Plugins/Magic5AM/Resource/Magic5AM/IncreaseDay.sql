UPDATE _UsersDays INNER JOIN _Users ON _UsersDays._KeyToUsers = _Users._id
SET _CurrentDay=_CurrentDay+1, _DateOfLastUpdate=UNIX_TIMESTAMP()
WHERE _UserId=:_UserId;