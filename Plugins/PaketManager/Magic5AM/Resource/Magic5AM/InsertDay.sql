INSERT INTO _UsersDays
(_KeyToUsers,
_CurrentDay,
_DateOfLastUpdate)
VALUES
(
(SELECT _id
FROM _Users
WHERE _UserId=:_UserId),
1,
0
);