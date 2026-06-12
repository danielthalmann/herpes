
export const decodeHTML = (str: string) => {
    const el = document.createElement('textarea');
    el.innerHTML = str;
    return el.value;
}
