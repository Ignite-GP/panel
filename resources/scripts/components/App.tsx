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
    igniteUser?: {
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
    const { igniteUser, SiteConfiguration, StoreConfiguration } = window as ExtendedWindow;

    if (igniteUser && !store.getState().user.data) {
        store.getActions().user.setUserData({
            uuid: igniteUser.uuid,
            username: igniteUser.username,
            email: igniteUser.email,
            approved: igniteUser.approved,
            discordId: igniteUser.discord_id,
            language: igniteUser.language,
            rootAdmin: igniteUser.root_admin,
            useTotp: igniteUser.use_totp,
            referralCode: igniteUser.referral_code,
            createdAt: new Date(igniteUser.created_at),
            updatedAt: new Date(igniteUser.updated_at),
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
