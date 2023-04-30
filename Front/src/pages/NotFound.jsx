import React, { useEffect, useState } from 'react'
import { Button, Col, Container, Row } from 'react-bootstrap'
import { useUserContext } from '../contexts/UserContext';

const NotFound = () => {
    const [state, setState] = useState("guest");
    const { user, token } = useUserContext();
    useEffect(() => {
        if (token != null) {
            switch (user.role) {
                case "client":
                    setState("client")
                    break;
                case "admin":
                    setState("admin")
                    break;
            }
        }
    }, [token, user.role])
    const stateButton = {
        client: { href: "/home", label: "Go Home" },
        admin: { href: "/dashboard", label: "Go Home" },
        guest: { href: "/login", label: "Go Home" },
    };
    const { href, label } = stateButton[state];
    return (
        <Container className="d-flex align-items-center justify-content-center vh-100">
            <Row>
                <Col className="text-center">
                    <h1 className="display-1 fw-bold">404</h1>
                    <p className="fs-3"><span className="text-danger">Oops!</span> Page not found.</p>
                    <p className="lead">The page you’re looking for doesn’t exist.</p>
                    <Button href={href} variant="primary">{label}</Button>
                </Col>
            </Row>
        </Container>
    )
}

export default NotFound