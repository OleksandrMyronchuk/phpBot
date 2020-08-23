UPDATE _UsersDays
INNER JOIN _Users
ON _Users._id=_UsersDays._KeyToUsers
SET _UsersDays._CurrentDay = :_CurrentDay
WHERE _Users._UserId=:_UserId;