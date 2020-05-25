var APIKey = '11f2ff5a50fcce4df43aa4c897d132d3f5ad4a84ed0aec7be67718deb5120192';

$.getJSON('https://api.unsplash.com/search/photos?query=mono&per_page=50&client_id=11f2ff5a50fcce4df43aa4c897d132d3f5ad4a84ed0aec7be67718deb5120192', function(data) {
    console.log(data);
    var imageList = data.results;
    $.each(imageList, function(i, val) {
        var image = val;
        var imageURL = val.urls.regular;
        var imageWidth = val.width;
        var imageHeight = val.height;
        if (imageWidth > imageHeight) {
            $('body').vegas({
                overlay: true,
                transition: 'fade',
                transitionDuration: 4000,
                delay: 10000,
                color: 'red',
                animation: 'random',
                animationDuration: 20000,
                slides: [
                    { src: imageURL}
                ]
            });
        }

    });

});