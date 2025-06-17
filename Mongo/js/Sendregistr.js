{
  "_id": ObjectId("5f8d0d3b5e1c2a3b4c5d6e7f"),
  "username": "john_doe",
  "email": "john@example.com",
  "password": "$2y$10$N9qo8uLOickgx2ZMRZoMy.Mrq1V1k4X7.K4lB9k7JYJ1dQr2DZG.u", // хеш пароля
  "createdAt": ISODate("2023-10-15T10:00:00Z"),
  "updatedAt": ISODate("2023-10-15T10:00:00Z"),
  "roles": ["user"],
  "isActive": true,
  "profile": {
    "firstName": "John",
    "lastName": "Doe",
    "avatar": "path/to/avatar.jpg"
  },
  "auth": {
    "lastLogin": ISODate("2023-10-20T08:30:00Z"),
    "failedAttempts": 0,
    "lockUntil": null
  }
}