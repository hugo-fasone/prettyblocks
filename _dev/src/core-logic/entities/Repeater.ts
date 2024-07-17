import { PrimitiveFieldType, REPEATER_TYPE } from "./ElementType";

import { ComponentContent } from "./ComponentContent";
import { PrimitiveFieldContent } from "./PrimitiveFieldContent";

export type Repeater<
  C extends ComponentContent | PrimitiveFieldContent<PrimitiveFieldType>
> = {
  id: string;
  component_id: string;
  type: REPEATER_TYPE;
  label: string;
  sub_elements: C[];
};
