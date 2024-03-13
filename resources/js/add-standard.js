document.addEventListener("DOMContentLoaded", function () {
    const searchStandardInput = document.querySelector('#input-search-standard');
    const tableBody = document.querySelector('#table-search-standard');
    const listStandard = document.querySelector('._list-standard');
    const formAddStandard = document.getElementById('form-add-standard');
    let rowIDs = window.rowIDs;
    const onClickAddButton = (event) => {
        if (event.target.closest('.add-button-standard')) {
            const button = event.target.closest('.add-button-standard');
            const row = button.parentNode.parentNode; // Get the <tr> element
            const rowTitle = row.querySelector('td:nth-child(2)').textContent;
            const rowID = parseInt(button.getAttribute('data-id'));
            const point = button.getAttribute('data-point');
            const rowCode = button.getAttribute('data-code');
            if (!rowIDs.includes(rowID)) {
                formAddStandard.innerHTML += `
                        <tr class="input-standard-box">
                                <td style="background: #d0f1e1">${rowCode}</td>
                                <td style="background: #d0f1e1">${rowTitle}</td>
                                <td  style="background: #d0f1e1" class="text-center">${point}</td>
                                <td style="background: #d0f1e1" class="text-center">
                                    <input class="form-control tw-min-w-[80px] tw-ml-2" type="number"
                                           value="${point}" min="0"
                                           max="${point}"
                                           name="standards[${rowID}][point]">
                                </td>
                                <td style="background: #d0f1e1">
                                    <button class="btn text-danger delete-button" type="button">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                   <input type="hidden" value="${rowID}" name="standards[${rowID}][id]">
                                </td>
                            </tr>
        `
                rowIDs.push(rowID);
            }
        }
    }


    searchStandardInput.addEventListener('input', (event) => {
        const query = event.target.value;
        if (query !== '')
            fetch('/standards/search?query=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    let html = '';
                    data.forEach(row => {
                        console.log(row)
                        html += `<tr>
                            <td>${row.code}</td>
                            <td> ${row.point} </td>
                            <td>${row.content}</td>
                            <td>
                                <div data-id="${row.id}"
                                data-point="${row.point}"
                                data-code="${row.code}"
                                 class="tw-cursor-pointer tw-text-3xl tw-text-blue-400 tw-font-bold add-button-standard">
                                    <i class="bi bi-plus"></i>
                                </div>
                            </td>
                        </tr>`
                    })
                    tableBody.innerHTML = html;

                    tableBody.addEventListener('click', onClickAddButton);

                })
                .catch(error => {
                    console.error('There was an error!', error);
                });
    })

    tableBody.addEventListener('click', onClickAddButton);

    formAddStandard.addEventListener('click', (event) => {
        if (event.target.closest('.delete-button')) {
            const divToRemove = event.target.closest('.input-standard-box'); // Target the enclosing div
            divToRemove.remove();
            const deletedRowCode = divToRemove.querySelector('input[type="hidden"]').value;
            rowIDs = rowIDs.filter(code => code != deletedRowCode);
        }
    });

});
