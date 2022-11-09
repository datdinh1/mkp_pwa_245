module.exports = (targets) => {
    const buildpackTargets = targets.of("@magento/pwa-buildpack");
    buildpackTargets.envVarDefinitions.tap((defs) => {
        defs.sections.push({
            name: "Marketplace",
            variables: [
                {
                    name: "STOREFRONT_LANGUAGE_CODE",
                    type: "str",
                    desc: "Language code for storefront, i.e. en, th",
                    default: 'en'
                },
                {
                    name: "FACEBOOK_API_KEY",
                    type: "str",
                    desc: "Facebook API Key"
                },
                {
                    name: "GOOGLE_API_KEY",
                    type: "str",
                    desc: "Google API Key"
                },
            ],
        });
    });
};
