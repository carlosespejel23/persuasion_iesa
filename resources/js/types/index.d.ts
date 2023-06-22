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

export interface Comentarios {
    id: number;
    usuarios_id: number;
    posts_id: number;
    nombre: string
    apellidoPaterno: string,
    apellidoMaterno: string,
    contenido: string;
    estado: number;
    created_at: string;
    updated_at: string;
}

export interface Deudor {
    id: number;
    usuario_id: number;
    nombre: string;
    apellidoPaterno: string;
    apellidoMaterno: string;
    email: string;
    telefono: string;
    monto_a_pagar: number;
    monto_pagado: number;
    created_at: string;
    updated_at: string;
}

export interface ComentarioActualizarDeuda {
    id: number;
    usuario_id: number;
    deudor_id: number;
    comentario: string;
    created_at: string;
    updated_at: string;
}

export interface ComentarioDeudaPago {
    id: number;
    usuario_id: number;
    deudor_id: number;
    comentario: string;
    created_at: string;
    updated_at: string;
}

export interface EmojiConfig {
    id: number;
    usuario_id: number;
    enojo: string;
    like: string;
    comentar: string;
    compartir: string;
    created_at: string;
    updated_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
        noticia: Noticia;
        comentarios: Comentarios;
        deudor: Deudor;
        comentarioActualizarDeuda: ComentarioActualizarDeuda;
        comentarioDeudaPago: ComentarioDeudaPago;
        emojiConfig: EmojiConfig;
    };
};
