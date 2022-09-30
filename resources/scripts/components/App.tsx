import React from 'react';
import tw from 'twin.macro';
import '@/assets/tailwind.css';
import { store } from '@/state';
import { StoreProvider } from 'easy-peasy';
import { hot } from 'react-hot-loader/root';
import { history } from '@/components/history';
import { SiteSettings } from '@/state/settings';
import IndexRouter from '@/routers/IndexRouter';
import earnCredits from '@/api/account/earnCredits';
import { setupInterceptors } from '@/api/interceptors';
import { StorefrontSettings } from '@/state/storefront';
import GlobalStylesheet from '@/assets/css/GlobalStylesheet';

interface ExtendedWindow extends Window {
    SiteConfiguration?: SiteSettings;
    StoreConfiguration?: StorefrontSettings;
    IgniteUser?: {
        uuid: string;
        username: string;
        email: string;
        approved: boolean;
        /* eslint-disable camelcase */
        discord_id: string;
        root_admin: boolean;
        use_totp: boolean;
        referral_code: string;
        language: string;
        updated_at: string;
        created_at: string;
        /* eslint-enable camelcase */
    };
}

setupInterceptors(history);

const App = () => {
    const { IgniteUser, SiteConfiguration, StoreConfiguration } = window as ExtendedWindow;

    if (IgniteUser && !store.getState().user.data) {
        store.getActions().user.setUserData({
            uuid: IgniteUser.uuid,
            username: IgniteUser.username,
            email: IgniteUser.email,
            approved: IgniteUser.approved,
            discordId: IgniteUser.discord_id,
            language: IgniteUser.language,
            rootAdmin: IgniteUser.root_admin,
            useTotp: IgniteUser.use_totp,
            referralCode: IgniteUser.referral_code,
            createdAt: new Date(IgniteUser.created_at),
            updatedAt: new Date(IgniteUser.updated_at),
        });
    }

    if (!store.getState().settings.data) {
        store.getActions().settings.setSettings(SiteConfiguration!);
    }

    if (!store.getState().storefront.data) {
        store.getActions().storefront.setStorefront(StoreConfiguration!);
    }

    function earn() {
        setTimeout(earn, 61000); // Allow 1 second for time inconsistencies.
        earnCredits().catch(() => console.error('Failed to add credits'));
    }

    earn();

    return (
        <>
            <GlobalStylesheet />
            <StoreProvider store={store}>
                <div css={tw`mx-auto w-auto`}>
                    <IndexRouter />
                </div>
            </StoreProvider>
        </>
    );
};

export default hot(App);
