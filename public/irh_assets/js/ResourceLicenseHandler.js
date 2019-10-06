class ResourceLicenseHandler
{
	constructor()
	{
		this.attributionLicenseBtn 		= $('#attribution_license');
		this.sharealikeLicenseBtn 		= $('#sharealike_license');
		this.nonDerivativeLicenseBtn 	= $('#nonderivative_license');

		this.activeLicense 				= $('#active_license');
		this.activeLicense.val('sharealike_license'); // Activating ShareAlike License By Default
		// Listening events
		this.events();
	}

	// Events
	events()
	{
		this.attributionLicenseBtn.on('click',this.activateAttributionLicense.bind(this));
		this.sharealikeLicenseBtn.on('click',this.activateShareAlikeLicense.bind(this));
		this.nonDerivativeLicenseBtn.on('click',this.activateNonDerivateLicense.bind(this));
	}

	// Event Handlers
	activateAttributionLicense()
	{
		this.activeLicense.val('attribution_license');
		this.changeButtonTheme(this.attributionLicenseBtn.bind(this),'activate');
		this.changeButtonTheme(this.sharealikeLicenseBtn.bind(this),'deactivate');
		this.changeButtonTheme(this.nonDerivativeLicenseBtn.bind(this),'deactivate');
	}

	activateShareAlikeLicense()
	{
		this.activeLicense.val('sharealike_license');
		this.changeButtonTheme(this.attributionLicenseBtn.bind(this),'deactivate');
		this.changeButtonTheme(this.sharealikeLicenseBtn.bind(this),'activate');
		this.changeButtonTheme(this.nonDerivativeLicenseBtn.bind(this),'deactivate');
	}

	activateNonDerivateLicense()
	{
		this.activeLicense.val('nonderivative_license');
		this.changeButtonTheme(this.attributionLicenseBtn.bind(this),'deactivate');
		this.changeButtonTheme(this.sharealikeLicenseBtn.bind(this),'deactivate');
		this.changeButtonTheme(this.nonDerivativeLicenseBtn.bind(this),'activate');
	}

	changeButtonTheme(btn,status)
	{
		if(status == 'activate')
		{
			btn.addClass('btn-success');
			btn.removeClass('btn-accent');
			btn.text('Selected');
		}
		else
		{
			btn.addClass('btn-accent');
			btn.removeClass('btn-success');
			btn.text('Choose');
		}
	}
}

var licenseHandler = new ResourceLicenseHandler();