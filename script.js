document.addEventListener("DOMContentLoaded", load);

function load() {
    var sort = document.getElementById('sortform');

    sort.addEventListener('submit', function(event) {
        event.preventDefault();
        console.log('test');
    });
}