import { Noticia } from './index.d';
export interface User {
    id: number;
    nombre: string;
    apellidoPaterno: string,
    apellidoMaterno: string,
    telefono: string,
    email: string;
    email_verified_at: string;
}

export interface Noticia {
    id: number;
    usuarios_id: number;
    nombre: string
    apellidoPaterno: string,
    apellidoMaterno: string,
    slug: string;
    contenido: string;
    estado: number;
    post_anonimo: number;
    created_at: string;
    updated_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
        noticia: Noticia;
    };
};
