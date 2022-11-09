module.exports = (targets) => {
    targets.of("@magento/venia-ui").routes.tap((routes) => {
        routes.push({
            name: "MyGreetingRoute",
            pattern: "/greeting/:who?",
            layout: 'default',
            path: require.resolve("../components/GreetingPage/index.js"),
        });
        return routes;
    });
};
