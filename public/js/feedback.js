function ask(route) {
    let isAccepted = confirm("Оставить обратную связь?");
    if (isAccepted) {
        let url = new URL(route);
        url.searchParams.set("accepted", '1');
        window.location.href = url;
    }
}
