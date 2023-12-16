import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';
import { Observable } from 'rxjs';
import { Product } from '../models/product.model';

@Injectable({
  providedIn: 'root'
})
export class CartService {
  private apiUrl = environment.apiUrl;

  constructor(private http: HttpClient) { }

  createCart(sessionId: string): Observable<any> {
    const headers = { 'X-Session-Id': sessionId };
    return this.http.post(`${this.apiUrl}/cart`, {}, { headers });
  }

  getCart(sessionId: string): Observable<any> {
    const headers = { 'X-Session-Id': sessionId };
    return this.http.get(`${this.apiUrl}/cart`, { headers });
  }

  getCartDetails(sessionId: string): Observable<any> {
    const headers = { 'X-Session-Id': sessionId };
    return this.http.get(`${this.apiUrl}/cart/details`, { headers });
  }

  addToCart(sessionId: string, productId: string, quantity: number): Observable<any> {
    const headers = { 'X-Session-Id': sessionId };
    return this.http.post(`${this.apiUrl}/cart/items`, { productId, quantity }, { headers });
  }

  removeFromCart(sessionId: string, id: string): Observable<any> {
    const headers = { 'X-Session-Id': sessionId };
    return this.http.delete(`${this.apiUrl}/cart/items/${id}`, { headers });
  }

  updateCartItem(sessionId: string, id: string, quantity: number): Observable<any> {
    const headers = { 'X-Session-Id': sessionId };
    return this.http.put(`${this.apiUrl}/cart/items/${id}`, { quantity }, { headers });
  }

  checkout(sessionId: string): Observable<any> {
    const headers = { 'X-Session-Id': sessionId };
    return this.http.delete(`${this.apiUrl}/cart/checkout`, { headers });
  }
}