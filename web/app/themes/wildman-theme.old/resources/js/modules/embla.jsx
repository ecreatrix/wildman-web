import EmblaCarousel from 'embla-carousel'
import { addPrevNextBtnsClickHandlers } from './embla-buttons'
import Autoplay from 'embla-carousel-autoplay'



export function startCarousel() {
	const allEmblaCarousels = document.querySelectorAll("[data-embla-carousel-init]")

	for (var i in allEmblaCarousels) {
		if (allEmblaCarousels.hasOwnProperty(i)) {
			let emblaNode = allEmblaCarousels[i]

			const viewportNode = emblaNode.querySelector('.embla__viewport')
			const prevBtnNode = emblaNode.querySelector('.embla__button--prev')
			const nextBtnNode = emblaNode.querySelector('.embla__button--next')

			const data = emblaNode.dataset

			const duration = data?.emblaCarouselDuration || 25
			const delay = data?.emblaCarouselDuration || 500
			const loop = data?.emblaCarouselLoop || true

			const OPTIONS = { duration, loop, delay }

			//console.log(OPTIONS)
			//const autoplayOptions = {  delay:0,  rootNode: (emblaNode: HTMLElement) => emblaNode.parentElement}
			const plugins = [Autoplay()]

			const emblaApi = EmblaCarousel(viewportNode, OPTIONS, plugins)

			const removePrevNextBtnsClickHandlers = addPrevNextBtnsClickHandlers(
				emblaApi,
				prevBtnNode,
				nextBtnNode
			)

			emblaApi.on('destroy', removePrevNextBtnsClickHandlers)
		}
	}
}