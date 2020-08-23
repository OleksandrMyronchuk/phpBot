SELECT _Users._id, _CurrentDay, _DateOfLastUpdate
FROM _UsersDays
INNER JOIN _Users
ON _UsersDays._KeyToUsers=_Users._id
WHERE _Users._UserId=:_UserId;