const crypto = require('crypto');

crypto.randomBytes(48, function(err, buffer) {
  const token = buffer.toString('hex');
  console.log(token);
});