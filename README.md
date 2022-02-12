# teamway-assessment
 
API Listing:
=============

users - Controller
------------------
users/:id/shifts ==> getShiftsByUserId
users            ==> users
users/:id        ==> getUsersById
users/:id/accounts ==> updateAccountsByUserIdAccounts
users/:id/shifts/current ==> getCurrentShiftsByUserId
users/:id/shifts/:id/current ==> getCurrentShiftByUserIdAndShiftId


shifts - Controller
-------------------
shifts  ==> shifts
shifts/:id ==> getShiftById
shifts/:id/users ==> getUsersByShiftId
shifts/current ==> getCurrentShift
shifts/current/users ==> getUsersByCurrentShift
shifts/current/users/:id ==> getUsersByCurrentShiftAndUserId

