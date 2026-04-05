const addTogglePrevNextBtnsActive = (emblaApi, prevBtn, nextBtn) => {
	const togglePrevNextBtnsState = () => {
		if (emblaApi.canScrollPrev()) prevBtn.removeAttribute('disabled')
			else prevBtn.setAttribute('disabled', 'disabled')

		if (emblaApi.canScrollNext()) nextBtn.removeAttribute('disabled')
			else nextBtn.setAttribute('disabled', 'disabled')
	}

	emblaApi
		.on('select', togglePrevNextBtnsState)
		.on('init', togglePrevNextBtnsState)
		.on('reInit', togglePrevNextBtnsState)

	return () => {
		prevBtn.removeAttribute('disabled')
		nextBtn.removeAttribute('disabled')
	}
}

export const onNavButtonClick = (emblaApi) => {
	const autoplay = emblaApi?.plugins()?.autoplay
	if (!autoplay) return

	const resetOrStop =
		autoplay.options.stopOnInteraction === false
		? autoplay.reset
		: autoplay.stop

	resetOrStop()
}

export const addPrevNextBtnsClickHandlers = (
	emblaApi,
	prevBtn,
	nextBtn
) => {
	const scrollPrev = () => {
		emblaApi.scrollPrev()
		if (onNavButtonClick) onNavButtonClick(emblaApi)
	}

	const scrollNext = () => {
		emblaApi.scrollNext()
		if (onNavButtonClick) onNavButtonClick(emblaApi)
	}

	prevBtn.addEventListener('click', scrollPrev, false)
	nextBtn.addEventListener('click', scrollNext, false)

	const removeTogglePrevNextBtnsActive = addTogglePrevNextBtnsActive(
		emblaApi,
		prevBtn,
		nextBtn
		)

	return () => {
		removeTogglePrevNextBtnsActive()
		prevBtn.removeEventListener('click', scrollPrev, false)
		nextBtn.removeEventListener('click', scrollNext, false)
	}
}
