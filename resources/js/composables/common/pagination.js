export const setPaginationData = (data) => {

    pagination.value = {

        first_url: data.links.first,
        last_url: data.links.last,
        next_url: data.links.next,
        prev_url: data.links.prev,
        last_page: data.meta.last_page,
        links: data.meta.links,
        total: data.meta.total
    }
}
