/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';


const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

// start the Stimulus application
import './bootstrap';

import 'bootstrap-icons/font/bootstrap-icons.css';

document.querySelector('#favlist').addEventListener('click', addToFavlist)

function addToFavlist(event)
{
    event.preventDefault();

    const favlistLink = event.currentTarget;
    const link = favlistLink.href;
    // Send an HTTP request with fetch to the URI defined in the href
    try {
        fetch(link)
        // Extract the JSON from the response
            .then(res => res.json())
        // Then update the icon
            .then(data => {
                const favlistIcon = favlistLink.firstElementChild;
                if (data.isInFavlist) {
                    favlistIcon.classList.remove("bi-bookmark-plus"); // Remove the .bi-heart (empty heart) from classes in <i> element
                    favlistIcon.classList.add("bi-bookmark-x-fill"); // Add the .bi-heart-fill (full heart) from classes in <i> element
                } else {
                    favlistIcon.classList.remove("bi-bookmark-x-fill"); // Remove the .bi-heart-fill (full heart) from classes in <i> element
                    favlistIcon.classList.add("bi-bookmark-plus"); // Add the .bi-heart (empty heart) from classes in <i> element
                }
            });
    } catch (err) {
        // eslint-disable-next-line no-console
        console.error(err);
    }
}
