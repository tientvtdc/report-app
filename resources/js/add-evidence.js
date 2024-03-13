document.addEventListener("DOMContentLoaded", function () {
    const listSearchEvidence = document.getElementById('list-search-evidence');
    const listAddEvidence = document.getElementById('list-add-evidence');
    const inputSearchEvidence = document.getElementById('search-evidence');
    const inputIdStandard = document.querySelector('.input-id-standard');
    let rowIDs = [];
    let currentPage = 1; // Theo dõi trang hiện tại
    let q = '';
    let isLoadMore = true;
    let filterDate = 'desc';

    const filterBtns = document.querySelectorAll('.btn-filter');

    filterBtns.forEach(filterBtn => {
        filterBtn.addEventListener('click', evt => {
            const sortBy = evt.target.getAttribute('data-sort-by');
            if (filterDate !== sortBy) {
                filterDate = sortBy;
                isLoadMore = true;
                loadMoreEvidence();
                filterBtns.forEach(btn => btn.classList.toggle('active', btn === evt.target));
            }
        });

    })

    listSearchEvidence.addEventListener('scroll', function () {
        if (listSearchEvidence.scrollHeight - listSearchEvidence.scrollTop === listSearchEvidence.clientHeight) {
            if (currentPage < lastPage) {
                loadMoreEvidence();
            }
        }
    });

    // Thêm sự kiện nút
    const onClickAddButton = (event) => {
        if (event.target.closest('.add-button-evidence')) {
            const rowID = event.target.getAttribute('data-id');
            if (!rowID) return;
            if (!rowIDs.includes(rowID)) {
                const title = event.target.getAttribute('data-title');
                listAddEvidence.innerHTML += `
            <div class="flex-row d-flex justify-content-between mt-1 input-evidence-box">
                <div class="tw-truncate" title="${event.target.textContent}">
                    <button class="btn text-danger delete-button-input-evidence"

                    >
                           <i class="bi bi-x-lg"></i>
                    </button>
                     ${title}
                     <input type="hidden" value="${rowID}" name="evidences[${rowIDs.length + 1}][id]">
                </div>
                <input class="form-control form-control-sm tw-w-24" value="0"  name="evidences[${rowIDs.length + 1}][code]"/>
            </div>
            `
                rowIDs.push(rowID);
            }

        }
    }

    const onClickRemoveInput = (event) => {
        if (event.target.closest('.delete-button-input-evidence')) {
            const isConfirm = confirm("Bạn muốn gỡ?")
            if (isConfirm) {
                const divToRemove = event.target.closest('div.input-evidence-box');
                divToRemove.remove();
                const deletedRowCode = divToRemove.querySelector('input[type="hidden"]').value;
                rowIDs = rowIDs.filter(code => code !== deletedRowCode);
            } else {
                event.preventDefault();
            }
        }
    }


    const addEvidenceModal = document.getElementById('addEvidenceModal');

    if (addEvidenceModal) {
        addEvidenceModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const assessmentCriterionStandardsID = button.getAttribute('data-id');
            inputIdStandard.value = assessmentCriterionStandardsID;
            rowIDs = [];
            getEvidences(assessmentCriterionStandardsID);
            isLoadMore = true;
            loadMoreEvidence();
        });
    }

    inputSearchEvidence.addEventListener('input', (e) => {
        q = e.target.value;
        currentPage = 1;
        listSearchEvidence.innerHTML = '';
        isLoadMore = true;
        loadMoreEvidence();
    })

    function loadMoreEvidence() {
        if (currentPage === 1) listSearchEvidence.innerHTML = '';
        if (isLoadMore) {
            fetch(`/evidences/search?page=${currentPage}&q=${q ?? ''}&sortBy=${filterDate}`)
                .then(response => response.json())
                .then(data => {
                    for (const evidence of data.data) {
                        const dateTime = new Date(evidence.created_at);
                        const expireDate = evidence.valid_to ? new Date(evidence.valid_to) : Date.now();
                        const isStillValid = (expireDate < Date.now() && evidence.valid_to);
                        listSearchEvidence.innerHTML += `
                        <button
                         type="button"
                         data-title="${evidence.title}"
                         class="btn text-start tw-text-blue-500 hover:tw-text-blue-700
                          add-button-evidence ${isStillValid && 'tw-text-red-500'} "
                         data-id="${evidence.id}"
                         title="\nHiệu lực: ${evidence.valid_from ? (new Date(evidence.valid_from))
                            .toLocaleDateString() : ''}-${
                            evidence.valid_to ? expireDate.toLocaleDateString() :
                                ''}\nĐăng bởi ${evidence.creator.name
                        }${evidence?.editor ? '\nChỉnh sửa bởi ' + evidence?.editor.name
                            + ' lúc ' + (new Date(evidence.updated_at)).toLocaleTimeString() +
                            (new Date(evidence.updated_at)).toLocaleDateString() : ''}
                         "

                        >
                         ${evidence.title}
                         <span class="tw-italic tw-text-gray-400">
                                 (${dateTime.toLocaleTimeString()}  ${dateTime.toLocaleDateString()})
                        </span>
                        </button>
                    `
                    }

                    if (data.next_page_url) {
                        if (listSearchEvidence.scrollHeight <= listSearchEvidence.clientHeight) {
                            loadMoreEvidence();
                        }
                    } else {
                        isLoadMore = false
                    }
                })
                .catch(error => console.error('Lỗi khi load dữ liệu:', error));
        }
    }

    function getEvidences(id) {
        fetch(`/evidences/get-evidences/${id}`)
            .then(response => response.json())
            .then(data => {
                let html = '';
                data.forEach(item => {
                    html += `
                        <div class="flex-row d-flex justify-content-between mt-1 input-evidence-box">
                <div class="tw-truncate" title="${item.evidence.title}">
                    <button class="btn text-danger delete-button-input-evidence"
                     ${(window.userRole !== "SUPER_ADMIN" && item.added_by !== window.user_id) ? "disabled" : ''}
                     >
                           <i class="bi bi-x-lg"></i>
                    </button>
                     ${item.evidence.title}
                     <input type="hidden" value="${item.evidence.id}" name="evidences[${rowIDs.length + 1}][id]">
                     </div>
                  <input class="form-control form-control-sm tw-w-24" value="${item.code}"
                  type="tel"
                   name="evidences[${rowIDs.length + 1}][code]" />
                </div>
                    `
                    rowIDs.push(item.evidence.id + '');

                })
                listAddEvidence.innerHTML = html;
            })
            .catch(error => console.error('Lỗi khi load dữ liệu:', error));
    }

    listSearchEvidence.addEventListener('click', onClickAddButton);
    listAddEvidence.addEventListener('click', onClickRemoveInput);

});
