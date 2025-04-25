export interface UserType {
    id: number
    name: string
    firstname: string
    email: string
    type: string
    created_at: string
    updated_at: string
}

export interface CarouselItemType{
    title: string
    address: string
    city: string
    price: number
    capaxcity: number
    tags: string[]
}