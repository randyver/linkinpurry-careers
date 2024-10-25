document.addEventListener('DOMContentLoaded', function () {
    const companyInfos = document.querySelectorAll('.company-info');

    companyInfos.forEach(companyInfo => {
        companyInfo.addEventListener('click', function () {
            const companyId = this.getAttribute('data-company-id');
            if (companyId) {
                window.location.href = `/company-profile/${companyId}`;
            }
        });
    });
});
