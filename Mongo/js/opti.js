// Для коллекции users
db.users.createIndex({ "username": 1 }, { unique: true });
db.users.createIndex({ "email": 1 }, { unique: true });
db.users.createIndex({ "isActive": 1 });

// Для коллекции sessions
db.sessions.createIndex({ "token": 1 }, { unique: true });
db.sessions.createIndex({ "userId": 1 });
db.sessions.createIndex({ "expiresAt": 1 }, { expireAfterSeconds: 0 });

// Для коллекции password_resets
db.password_resets.createIndex({ "token": 1 }, { unique: true });
db.password_resets.createIndex({ "userId": 1 });
db.password_resets.createIndex({ "expiresAt": 1 }, { expireAfterSeconds: 0 });