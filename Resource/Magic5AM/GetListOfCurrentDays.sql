SELECT _Users._UserId, _Users._Username, _Users._FirstName,
_Users._LastName, _UsersDays._CurrentDay
FROM _Users
INNER JOIN _UsersDays ON _Users._id=_UsersDays._KeyToUsers