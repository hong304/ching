module.exports = {
    output: {
        publicPath: '/js/',
    },
    resolve: {
        alias: {
            'videojs-contrib-hls': __dirname + '/node_modules/videojs-contrib-hls/dist/videojs-contrib-hls'
        }
    }
};