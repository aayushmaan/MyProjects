module.exports = {
    'secretKey': '12345-67890-09876-54321',
    'mongoUrl' : process.env.MONGOLAB_MAROON_URI || process.env.MONGOLAB_URI || 'mongodb://localhost:27017/quiz',
    'facebook': {
        clientID: '894321897346426',
        clientSecret: 'c99302168d3b9198d2e235b6135f82ac',
        callbackURL: 'https://localhost:3443/users/facebook/callback'
    }
}
