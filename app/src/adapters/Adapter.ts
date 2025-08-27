export abstract class Adapter<type, dto = type> {
  abstract toType(data: Partial<dto> | Partial<type>): type;
  abstract toDto(data: Partial<dto> | Partial<type>): dto;
}
