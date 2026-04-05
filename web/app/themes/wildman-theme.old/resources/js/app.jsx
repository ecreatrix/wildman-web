import domReady from '@wordpress/dom-ready';
//import 'https://early.webawesome.com/webawesome@3.0.0-alpha.12/dist/components/details/details.js';

// Initialization for ES Users
import {
	Collapse,
	//Carousel,
	initTWE,
} from "tw-elements";

//import { initFlowbite, Accordion } from 'flowbite';

import { startCarousel } from './modules/embla'


domReady(() => {
	initTWE({ Collapse });
	//let accordionElement = 'accordion-collapse'
	//const accordion = new Accordion(document.getElementById(accordionElement))
	//initFlowbite();

	let flowbiteAccordions = document.querySelectorAll("[data-flowite-accordion-init]")
	//console.log(flowbiteAccordions)
	for (var i in flowbiteAccordions) {
		if (flowbiteAccordions.hasOwnProperty(i)) {
			//let accordionElement = document.getElement(flowbiteAccordions[i]);
			//new Accordion( accordionElement )
            //alert(flowbiteAccordions[i].getAttribute());
        }
    }  

    /*const twCarousel = document.querySelectorAll("[data-twe-carousel-init]")
	for (var i in twCarousel) {
		if (twCarousel.hasOwnProperty(i)) {
			console.log(twCarousel[i])
			const carousel = new Carousel(twCarousel[i], {
			    items: 3,
			    loop: true,
			    margin: 10
			});
		}
	}*/

	startCarousel()
});
