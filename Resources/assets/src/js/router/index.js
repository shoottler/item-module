import ItemsContainer from '../containers/ItemsContainer'
function loadView (view, path) {
  return () => import(/* webpackChunkName: "view-[request]" */ `../views/${path}/${view}.vue`)
}
export const routes = [
  {
    path     : 'items',
    name     : 'Items configuration',
    redirect : '/app/items/base',
    component: ItemsContainer,
    children : [
      {
        path     : 'base',
        name     : 'Items',
        redirect : '/app/items/base/list',
        component: loadView('Items', 'items'),
        children : [
          {
            path     : 'list',
            name     : 'items list',
            component: loadView('ItemsList', 'items'),
          },
          {
            path     : 'create',
            name     : 'Create an item',
            component: loadView('CreateItem', 'items'),
          },
          {
            path     : 'edit/:id',
            name     : 'Edit item',
            component: loadView('EditItem', 'items'),
            props    : true,
          },
        ],
      },
    ],
  },
]
