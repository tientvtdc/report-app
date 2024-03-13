document.addEventListener("DOMContentLoaded", function () {
    const listActivity = document.getElementById('list-activity');
    let isMore = true;
    let currentPage = 2;
    const urlParams = new URLSearchParams(window.location.search);
    const q = urlParams.get('q');

    listActivity.addEventListener('scroll', function () {
        if (listActivity.scrollHeight - listActivity.scrollTop === listActivity.clientHeight && isMore) {
            fetch(`/load-more-activity?page=${currentPage}&q=${q ?? ''}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    let html = '';
                    data.data.forEach(activity => {
                        html += `
                        <p>
                    <span class="tw-font-bold">${activity.causer.name} </span>
                    <span class="tw-italic tw-text-gray-500"> ( ${convertDateTime(activity.updated_at )})</span>
                    : ${activity.description}</p>
                        `
                    })
                    listActivity.innerHTML += html;
                    isMore = !!data.next_page_url;
                    currentPage++;
                })
        }
    });
})
function convertDateTime(datetimeString) {
    // Create a new Date object from the datetime string
    const dateTime = new Date(datetimeString);

    // Get the date and time components
    const year = dateTime.getFullYear();
    const month = ('0' + (dateTime.getMonth() + 1)).slice(-2); // Months are zero based
    const day = ('0' + dateTime.getDate()).slice(-2);
    const hours = ('0' + dateTime.getHours()).slice(-2);
    const minutes = ('0' + dateTime.getMinutes()).slice(-2);
    const seconds = ('0' + dateTime.getSeconds()).slice(-2);

    // Construct the formatted datetime string
    const formattedDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

    return formattedDateTime;
}
