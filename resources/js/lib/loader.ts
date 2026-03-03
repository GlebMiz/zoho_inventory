export const showLoader = () => {
    const loaderHtml = `
    <div id="loader" class="loader-wrapper">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    `;
    document.body.insertAdjacentHTML('beforeend', loaderHtml);
};

export const removeLoader = () => {
    document.getElementById('loader')?.remove();
};
