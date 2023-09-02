const fallbackCopyToClipboard = (text: string) => {
    const textarea = document.createElement('textarea');
    textarea.value = text;

    // Hide the textarea from page
    textarea.style.top = '0';
    textarea.style.left = '0';
    textarea.style.position = 'fixed';
    textarea.style.height = '0';
    textarea.style.width = '0';
    textarea.style.visibility = 'hidden';

    // Append the textarea and select the contents to be able to copy
    document.body.appendChild(textarea);
    textarea.focus();
    textarea.select();

    try {
        const copied = document.execCommand('copy');
        if (!copied) throw new Error('Could not copy the specified text to clipboard!');
        return false;
    } catch {
        return false;
    } finally {
        document.body.removeChild(textarea);
    }
};

export const copyToClipboard = (text: string) => {
    if (!navigator.clipboard) return fallbackCopyToClipboard(text);

    return navigator.clipboard.writeText(text);
};
