import React from 'react';
import { useQuery } from '@apollo/react-hooks';
import cmsPageQuery from '@magento/venia-ui/lib/queries/getCmsPage.graphql';
import { fullPageLoadingIndicator } from '@magento/venia-ui/lib/components/LoadingIndicator';
import RichContent from '@magento/venia-ui/lib/components/RichContent';
import { number } from 'prop-types';
import CategoryList from '@magento/venia-ui/lib/components/CategoryList';
import { Meta } from '@magento/venia-ui/lib/components/Head';

const CMSPage = props => {
    const { id } = props;
    const { loading, error, data } = useQuery(cmsPageQuery, {
        variables: {
            id: Number(id),
            onServer: false
        }
    });

    if (error) {
        if (process.env.NODE_ENV !== 'production') {
            console.error(error);
        }
        return <div>Page Fetch Error</div>;
    }

    if (loading) {
        return fullPageLoadingIndicator;
    }

    if (data) {
        let content;
        // Only render <RichContent /> if the page isn't empty and doesn't contain the default CMS Page text.
        if (
            data.cmsPage.content &&
            data.cmsPage.content.length > 0 &&
            !data.cmsPage.content.includes('CMS homepage content goes here.')
        ) {
            content = <RichContent html={data.cmsPage.content} />;
        } else {
            content = <CategoryList title="Shop by category" id={2} />;
        }

        return (
            <>
                <Meta
                    name="description"
                    content={data.cmsPage.meta_description}
                />
                <div className='container'>
                    {content}
                </div>
            </>
        );
    }
    return null;
};

CMSPage.propTypes = {
    id: number
};

export default CMSPage;
