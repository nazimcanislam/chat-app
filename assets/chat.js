// Scroll down to show the most recent messages in the messaging box (Works when the page is refreshed).
const messagesContainer = $('.messages-container');
document.querySelector('.messages-container').scrollTo(0, messagesContainer.scrollHeight);

const addContactButton = document.querySelector('.add-contact-button');
const contactSearch = document.querySelector('.add-contact-container input[type="text"]');
addContactButton.addEventListener('click', () => {
    contactSearch.classList.toggle('show');

    if (contactSearch.classList.contains('show')) {
        addContactButton.classList.replace('fa-plus', 'fa-times');
    } else {
        addContactButton.classList.replace('fa-times', 'fa-plus');
    }
});
