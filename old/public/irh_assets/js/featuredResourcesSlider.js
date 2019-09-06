class featuredResourcesSlider
{
	constructor()
	{
		this.counter = 1;
		this.slidesRows = $(".featuredslider_row");
		this.firstTwoRows = this.slidesRows.slice(0,2);
		this.thirdFourthRows = this.firstTwoRows.nextAll().slice(1,4);
	}


	events()
	{

	}


	// Events Handlers
}

var featuredResourcesSliderObj = new featuredResourcesSlider();