export const showPopover = (text: string) => {
    const popover = document.createElement('div');
    popover.textContent = text;
    popover.classList.add('f_popover');
    document.body.append(popover);
    setTimeout(() => {
        popover.classList.add('popover--showed');

        setTimeout(() => {
            popover.classList.remove('popover--showed');

            setTimeout(() => {
                popover.remove();
            }, 300);
        }, 5000);
    }, 100);
};
