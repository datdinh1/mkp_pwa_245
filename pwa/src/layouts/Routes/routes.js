import React, { Suspense, lazy } from 'react';
import { Route, Switch } from 'react-router-dom';

import { fullPageLoadingIndicator } from '@magento/venia-ui/lib/components/LoadingIndicator';
import MagentoRoute from 'src/components/MagentoRoute';

//Layouts
const PublicAppContent = lazy(() => import('../publicAppContent'));
const AccountLayout = lazy(() => import('../accountLayout'));
const StoreLayout = lazy(() => import('../storeLayout'));
const CartLayout = lazy(() => import('../cartLayout'));
const CheckoutLayout = lazy(() => import('../checkoutLayout'));
const ThankYouLayout = lazy(() => import('../thankYouLayout'));

//Pages
const HomePage = lazy(() => import('../../pages/Home'));
const BestSeller = lazy(() => import('../../pages/BestSeller'));
const HotDeal = lazy(() => import('../../pages/HotDeal'));
const RecommendProduct = lazy(() => import('../../pages/RecommendProduct'));
const NewArrival = lazy(() => import('../../pages/NewArrival'));
const Account = lazy(() => import('../../pages/Account'));
const Favourite = lazy(() => import('../../pages/Favourite'));
const Coupon = lazy(() => import('../../pages/Coupon'));
const CollectCoupon = lazy(() => import('../../pages/CollectCoupon'));
const Follower = lazy(() => import('../../pages/Follower'));
const RecentlyViewed = lazy(() => import('../../pages/RecentlyViewed'));
const Setting = lazy(() => import('../../pages/Setting'));
const Profile = lazy(() => import('../../pages/Profile'));
const PaymentMethod = lazy(() => import('../../pages/PaymentMethod'));
const DeleteAccount = lazy(() => import('../../pages/DeleteAccount'));
const Store = lazy(() => import('../../pages/Store'));
const DeliveryAddress = lazy(() => import('../../pages/DeliveryAddress'));
const Auction = lazy(() => import('../../pages/Auction'));
const Cart = lazy(() => import('../../pages/Cart'));
const Checkout = lazy(() => import('../../pages/Checkout'));
const ThankYou = lazy(() => import('../../pages/ThankYou'));

const Routes = ({ isMasked }) => {
    return (
        <Suspense fallback={fullPageLoadingIndicator}>
            <Switch>
                <Route exact path="/">
                    <PublicAppContent isMasked={isMasked} pageTitle="Home">
                        <HomePage />
                    </PublicAppContent>
                </Route>
                <Route exact path="/best-seller">
                    <PublicAppContent isMasked={isMasked}>
                        <BestSeller />
                    </PublicAppContent>
                </Route>
                <Route exact path="/hot-deal">
                    <PublicAppContent isMasked={isMasked}>
                        <HotDeal />
                    </PublicAppContent>
                </Route>
                <Route exact path="/recommend-product">
                    <PublicAppContent isMasked={isMasked}>
                        <RecommendProduct />
                    </PublicAppContent>
                </Route>
                <Route exact path="/new-arrival">
                    <PublicAppContent isMasked={isMasked}>
                        <NewArrival />
                    </PublicAppContent>
                </Route>
                <Route exact path="/coupon">
                    <PublicAppContent isMasked={isMasked}>
                        <CollectCoupon />
                    </PublicAppContent>
                </Route>
                <Route exact path="/auction">
                    <PublicAppContent isMasked={isMasked}>
                        <Auction />
                    </PublicAppContent>
                </Route>
                <Route exact path="/account">
                    <AccountLayout isMasked={isMasked}>
                        <Account />
                    </AccountLayout>
                </Route>
                <Route exact path="/account/favourite">
                    <AccountLayout isMasked={isMasked}>
                        <Favourite />
                    </AccountLayout>
                </Route>
                <Route exact path="/account/coupon">
                    <AccountLayout isMasked={isMasked}>
                        <Coupon />
                    </AccountLayout>
                </Route>
                <Route exact path="/account/followers">
                    <AccountLayout isMasked={isMasked}>
                        <Follower />
                    </AccountLayout>
                </Route>
                <Route exact path="/account/recently-viewed">
                    <AccountLayout isMasked={isMasked}>
                        <RecentlyViewed />
                    </AccountLayout>
                </Route>
                <Route exact path="/account/settings">
                    <AccountLayout isMasked={isMasked}>
                        <Setting />
                    </AccountLayout>
                </Route>
                <Route exact path="/account/settings/profile">
                    <AccountLayout isMasked={isMasked}>
                        <Profile />
                    </AccountLayout>
                </Route>
                <Route exact path="/account/settings/payment-methods">
                    <AccountLayout isMasked={isMasked}>
                        <PaymentMethod />
                    </AccountLayout>
                </Route>
                <Route exact path="/account/settings/delivery-address">
                    <AccountLayout isMasked={isMasked}>
                        <DeliveryAddress />
                    </AccountLayout>
                </Route>
                <Route exact path="/account/settings/delete-account">
                    <AccountLayout isMasked={isMasked}>
                        <DeleteAccount />
                    </AccountLayout>
                </Route>
                <Route exact path="/shop/:name">
                    <StoreLayout isMasked={isMasked}>
                        <Store />
                    </StoreLayout>
                </Route>
                <Route exact path="/cart">
                    <CartLayout isMasked={isMasked}>
                        <Cart />
                    </CartLayout>
                </Route>
                <Route exact path="/checkout">
                    <CheckoutLayout isMasked={isMasked}>
                        <Checkout />
                    </CheckoutLayout>
                </Route>
                <Route exact path="/thankyou">
                    <ThankYouLayout isMasked={isMasked}>
                        <ThankYou />
                    </ThankYouLayout>
                </Route>
                <Route>
                    <PublicAppContent isMasked={isMasked}>
                        <MagentoRoute />
                    </PublicAppContent>
                </Route>
            </Switch>
        </Suspense>
    );
};

export default Routes;
