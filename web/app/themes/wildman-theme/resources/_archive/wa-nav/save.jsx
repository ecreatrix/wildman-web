/**
 * WordPress dependencies
 */
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

/**
 * Internal dependencies
 */
import { Burger, Center, Container, Group, Menu } from '@mantine/core';
import { useDisclosure } from '@mantine/hooks';

const links = [
	{ link: '/about', label: 'Features' },
	{
		link: '#1',
		label: 'Learn',
		links: [
			{ link: '/docs', label: 'Documentation' },
			{ link: '/resources', label: 'Resources' },
			{ link: '/community', label: 'Community' },
			{ link: '/blog', label: 'Blog' },
		],
	},
	{ link: '/about', label: 'About' },
	{ link: '/pricing', label: 'Pricing' },
	{
		link: '#2',
		label: 'Support',
		links: [
			{ link: '/faq', label: 'FAQ' },
			{ link: '/demo', label: 'Book a demo' },
			{ link: '/forums', label: 'Forums' },
		],
	},
];

export default function save( { attributes } ) {
	if ( attributes.ref ) {
		// Avoid rendering inner blocks when a ref is defined.
		// When this id is defined the inner blocks are loaded from the
		// `wp_navigation` entity rather than the hard-coded block html.
		//return;
	}

	//return <InnerBlocks />;
    const blockProps = useBlockProps.save();

    const items = links.map((link) => {
		const menuItems = link.links?.map((item) => (
			<Menu.Item key={item.link}>{item.label}</Menu.Item>
			));

		if (menuItems) {
			return (
				<Menu key={link.label} trigger="hover" transitionProps={{ exitDuration: 0 }} withinPortal>
					<Menu.Target>
						<a
							href={link.link}
							className="link"
							onClick={(event) => event.preventDefault()}
						>
							<Center>
								<span className="linkLabel">{link.label}</span>
								Chevron down icon
							</Center>
						</a>
					</Menu.Target>

					<Menu.Dropdown>{menuItems}</Menu.Dropdown>
				</Menu>
			);
		}

		return (
			<a
				key={link.label}
				href={link.link}
				className="link"
				onClick={(event) => event.preventDefault()}
			>
				{link.label}
			</a>
		);
	});

	console.log(items)

	const blockContent = attributes.navItems && attributes.navItems.map( ( nav ) => {
		//console.log(nav);

		const name = <span>{ nav.title.rendered }</span>
		return <div key={ nav.id }>
			{ name }
		</div>
	});
	//const [opened, { toggle }] = useDisclosure(false);

	return <header className="header">
			<Container size="md">
				<div className="inner">
					Logo
					<Group gap={5} visibleFrom="sm">
						{items}
					</Group>
					
					<Burger size="sm" hiddenFrom="sm" />
				</div>
			</Container>
		</header>

    return <div { ...blockProps }>{ blockContent }</div>;
}
